# 0 */1 * * * aws ecr get-login --no-include-email --region eu-central-1 | sh
0 2 16 */3 * certbot renew
# certbot certonly --agree-tos --email alexandr@zayats.org --manual -w /var/lib/letsencrypt/ -d rucheyok.org.ua -d www.rucheyok.org.ua --preferred-challenges dns
0 17 * * sun  mysqldump -uroot -p'Comcbidz05#' -h localhost --events --databases fontanelle > /tmp/backup.sql && tar -czvf /var/www/fontanelle/back-ups/$(date +\%Y-\%m-\%d-\%H-\%M).sql.tgz /tmp/backup.sql
0 18 * * sun  cd /var/www/fontanelle && git add . && git commit -m ' - backup' && git push
