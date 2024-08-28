   37  certbot --nginx
   55  certbot certonly --dry-run
   58  certbot certonly --nginx
   91  certbot certonly --dry-run --nginx
   93  certbot register --email alexandr@zayats.org
  121  certbot certonly --dry-run -d rucheyok.org.ua -d www.rucheyok.org.ua
  131  certbot certonly --dry-run --webroot -w /usr/share/nginx/html -d rucheyok.org.ua -d www.rucheyok.org.ua
  135  certbot certonly  --standalone --dry-run -d rucheyok.org.ua
  144  yum install certbot-nginx
  145  certbot certonly --dry-run --nginx -d rucheyok.org.ua
  147  certbot certonly --agree-tos --email alexandr@zayats.org --webroot -w /var/lib/letsencrypt/ -d rucheyok.org.ua -d www.rucheyok.org.ua
  148  certbot certonly --agree-tos --email alexandr@zayats.org --manual -w /var/lib/letsencrypt/ -d rucheyok.org.ua -d www.rucheyok.org.ua --preferred-challenges dns
