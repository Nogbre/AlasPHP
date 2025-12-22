
# 📘 Documentación del Proyecto (Docker + Laravel + Nginx + PostgreSQL)

Este documento explica de forma simple y profesional cómo ejecutar el proyecto con Docker, cómo funcionan los puertos, cómo agregar variables de entorno, cómo actúa el entrypoint y cómo manejar los seeds.

---

## 📑 Índice

1. [⚙️ Puertos para Pruebas Locales](#️-puertos-para-pruebas-locales)  
2. [🟣 Contenedor Laravel y Nginx](#-contenedor-laravel-y-nginx)  
3. [📝 Script de Inicio (entrypoint)](#-script-de-inicio-docker-entrypointsh)  
4. [📄 Importancia de `.env.example`](#-importancia-de-envexample)  
5. [🌱 Seeds en Laravel](#-seeds-en-laravel)  
6. [🌐 Variables de Entorno en Docker Compose](#-variables-de-entorno-en-docker-compose)  
7. [🚀 Despliegue del Proyecto](#-despliegue-del-proyecto)  
8. [📜 Ver Logs del Contenedor](#-ver-logs-del-contenedor)

---

# ⚙️ Puertos para Pruebas Locales

Este proyecto usa Docker (Laravel + Nginx + PostgreSQL).  
Solo necesitas ajustar los **puertos** y el **nombre del contenedor Laravel**.

---

<details>
<summary><strong>🔵 Puerto de Nginx (Acceso en el Navegador)</strong></summary>

```yaml
nginx:
  ports:
    - "8080:80"
````

* **8080** = puerto local (puede cambiarse)
* **80** = puerto interno de Nginx (no cambiar)

Si está ocupado:

```yaml
"8081:80"
"3000:80"
```

Acceso:

```
http://localhost:8080
```

</details>

---

<details>
<summary><strong>🟠 Puerto de PostgreSQL</strong></summary>

```yaml
"5432:5432"
```

Si tienes otro PostgreSQL activo:

```yaml
"5440:5432"
```

</details>

---

# 🟣 Contenedor Laravel y Nginx

Debe coincidir el nombre del contenedor:

```yaml
container_name: <Proyecto>-laravel
```

Usado en `nginx.conf`:

```nginx
fastcgi_pass <Proyecto>-laravel:9000;
```

---

# ✔ Resumen Rápido

* **Cambias:** `8080`, `5432 externo`, nombre del contenedor Laravel
* **No cambias:** `80`, `9000`, `5432 interno`

---

# 📝 Script de Inicio (`docker-entrypoint.sh`)

Este script automatiza:

* Crear `.env`
* Instalar dependencias
* Generar `APP_KEY`
* Asignar permisos
* Correr migraciones
* Iniciar PHP-FPM

Evita configuraciones manuales en cada arranque.

---

# 📄 Importancia de `.env.example`

`.env.example` funciona como **plantilla base** para el `.env`.

Ventajas:

* Evita subir contraseñas reales
* Estándar para cualquier entorno
* Permite al entrypoint crear el `.env` automáticamente

Sin este archivo, el contenedor no sabría qué variables generar.

---

# 🌱 Seeds en Laravel

<details>
<summary><strong>Seeders comentados en el entrypoint</strong></summary>

```sh
# php artisan db:seed --force || true
```

Actívalo solo si necesitas cargar datos iniciales.

</details>

---

<details>
<summary><strong>Registrar Seeders en Laravel</strong></summary>

Los seeders dentro de:

```
database/seeders/
```

no se ejecutan solos.
Debes agregarlos en `DatabaseSeeder.php`:

```php
public function run(): void
{
    $this->call([
        UserSeeder::class,
        RoleSeeder::class,
        ProductoSeeder::class,
    ]);
}
```

</details>

---

# 🌐 Variables de Entorno en Docker Compose

Puedes agregar más variables a Laravel desde `docker-compose.yml` usando la sección:

```yaml
environment:
  DB_HOST: db
  DB_DATABASE: <Proyecto>_db
  DB_USERNAME: admin
  DB_PASSWORD: admin123
```

### ➕ ¿Cómo agregar más variables?

Simplemente añade nuevas líneas:

```yaml
environment:
  APP_ENV: production
  APP_URL: https://tu-dominio.com
  SESSION_SECURE_COOKIE: true
  SESSION_SAME_SITE: lax
  LOG_CHANNEL: stack
  QUEUE_CONNECTION: database
  MAIL_MAILER: smtp
  MAIL_HOST: smtp.gmail.com
  API_BASE_URL_ADS: https://gatealas.dasalas.shop
  HELPDESK_API_URL: https://proyecto-de-ultimo-minuto.online
```

### ⚠ Importante

* Estas variables **sobrescriben** las del `.env` dentro del contenedor.
* Si agregas nuevas variables, asegúrate de que existan también en tu `.env.example`.
* **Para producción con SSL**: Usa URLs con `https://` y configura `SESSION_SECURE_COOKIE=true`.

---

# 🔒 Configuración SSL/HTTPS con Reverse Proxy

Este proyecto está diseñado para funcionar detrás de un **reverse proxy** (como Nginx Proxy Manager o Traefik) que maneja SSL/TLS.

### Arquitectura de Red

```
Internet → Reverse Proxy (SSL) → [proxy-network] → Nginx Container :80 → Laravel :9000
```

### Configuración del Reverse Proxy

1. **Instalar certificado SSL** (Let's Encrypt recomendado):
   - Configurar dominio en el reverse proxy
   - Generar certificado automático
   - Configurar renovación automática

2. **Proxy Pass**:
   - Apuntar al contenedor: `donaciones:80`
   - Habilitar WebSocket support (opcional)
   - Forward headers: `X-Forwarded-For`, `X-Forwarded-Proto`, `X-Forwarded-Host`

3. **Variables de entorno requeridas**:
   ```yaml
   environment:
     APP_ENV: production
     APP_URL: https://tu-dominio.com
     SESSION_SECURE_COOKIE: true
     SESSION_SAME_SITE: lax
     API_BASE_URL_ADS: https://gatealas.dasalas.shop
   ```

### Verificación Post-Configuración

```bash
# Verificar que el contenedor esté en las redes correctas
docker inspect donaciones | grep -A 10 "Networks"

# Debe mostrar: donaciones-net, internal-network, proxy-network
```

### Trust Proxies

El sistema ya incluye middleware `TrustProxies` configurado para detectar HTTPS correctamente cuando está detrás de un proxy.

---

# 🚀 Despliegue del Proyecto

Ejecutar:

```
docker compose up --build -d
```

Este comando puede tardar porque ejecuta todo el entrypoint.

---

# 🐢 ¿Se queda en “📦 Instalando dependencias de Composer…”?

Si ves:

```
Nothing to install, update or remove
```

y no avanza, es porque tu carpeta `vendor/` está afectando al contenedor.

### ✔ Solución

```
rm -rf vendor
docker compose up --build -d
```

---

# 📜 Ver Logs del Contenedor

```
docker logs <Proyecto>-laravel -f
```

Ejemplo:

```
docker logs <Proyecto>-laravel -f
```

O usando **Docker Desktop** → *Containers*.


