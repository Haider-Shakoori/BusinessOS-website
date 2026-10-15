#!/usr/bin/env bash
# Run on the existing BusinessOS cPanel host, never on the development VPS.
# This deploy does not touch public_html/index.php, public_html/.htaccess,
# the production .env, or any existing analytics/database rows.
set -Eeuo pipefail
umask 077

APP_DIR="/home/businessos/businessos-site"
PUBLIC_DIR="/home/businessos/public_html"
BACKUP_ROOT="/home/businessos/deployment-backups"
DB_FILE="${APP_DIR}/database/database.sqlite"
TARGET_COMMIT="0f45a1e4b472273b2758f5d5ca5c6291f0b99fa5"

fail() { printf 'DEPLOY ABORTED: %s\n' "$*" >&2; exit 1; }
[[ "$(id -un)" == businessos ]] || fail "Run as the authorized businessos cPanel account."
[[ -d "$APP_DIR/.git" ]] || fail "Expected production checkout missing: $APP_DIR"
[[ -f "$APP_DIR/.env" ]] || fail "Production .env missing."
[[ -f "$DB_FILE" ]] || fail "Production SQLite database missing; verify actual DB location before deploying."
[[ -f "$PUBLIC_DIR/index.php" ]] || fail "Live public entry point missing."
command -v php >/dev/null || fail "PHP CLI is unavailable."
command -v composer >/dev/null || fail "Composer is unavailable."

cd "$APP_DIR"
[[ "$(git branch --show-current)" == main ]] || fail "Production repository is not on main."
git diff --quiet || fail "Tracked working files have local changes; reconcile first."
git diff --cached --quiet || fail "Index contains staged local changes."

mkdir -p "$BACKUP_ROOT"
BACKUP="$BACKUP_ROOT/businessos-analytics-$(date -u +%Y%m%dT%H%M%SZ)"
mkdir "$BACKUP"
cp -p .env "$BACKUP/.env"
cp -p "$PUBLIC_DIR/index.php" "$BACKUP/public-index.php"
if [[ -f "$PUBLIC_DIR/.htaccess" ]]; then cp -p "$PUBLIC_DIR/.htaccess" "$BACKUP/public-htaccess"; fi
# VACUUM INTO creates a consistent, independent SQLite backup even with WAL.
php -r '$src=$argv[1]; $dst=$argv[2]; $db=new PDO("sqlite:".$src); $db->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION); $db->exec("VACUUM INTO ".$db->quote($dst));' "$DB_FILE" "$BACKUP/database.sqlite" || fail "SQLite backup failed; not deploying."
[[ -s "$BACKUP/database.sqlite" ]] || fail "SQLite backup is empty."
echo "Verified database/configuration backup: $BACKUP"

git fetch origin main
git merge --ff-only origin/main || fail "Fast-forward Git deployment failed."
git merge-base --is-ancestor "$TARGET_COMMIT" HEAD || fail "Expected analytics changes absent from updated main."

composer install --no-dev --no-interaction --prefer-dist --optimize-autoloader
php artisan migrate --force
php artisan optimize:clear
php artisan config:cache
php artisan view:cache

# Only sync static assets; do not overwrite production entrypoint or .htaccess.
if [[ -d public/assets ]]; then
    mkdir -p "$PUBLIC_DIR/assets"
    cp -a public/assets/. "$PUBLIC_DIR/assets/"
fi
for static_file in favicon.svg llms.txt; do
    if [[ -f "public/$static_file" ]]; then cp -p "public/$static_file" "$PUBLIC_DIR/$static_file"; fi
done

php artisan migrate:status | tail -18
echo "Production Git commit: $(git rev-parse HEAD)"
echo "Search Console property configured: $(php -r 'echo (getenv("SEARCH_CONSOLE_SITE_URL") ?: "inspect cached Laravel config on host");')"
echo "DEPLOY COMPLETED. Backup: $BACKUP"
echo "Next: open https://businessos.af/admin/analytics?days=365 as admin."
