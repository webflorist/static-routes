# static-routes
Generate static/hybrid pages for Laravel-Routes.

## Web Server Configuration

### Nginx
```
location / {
    root /path/to/static/routes;                    
    try_files $uri/index.html @default;
}

location @default {
     try_files $uri $uri/ /index.php?$query_string;
}
```