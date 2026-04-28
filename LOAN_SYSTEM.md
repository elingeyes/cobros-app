# Sistema de Gestión de Préstamos

## Descripción General
Sistema CRUD completo para gestionar clientes, tipos de préstamo, préstamos, cuotas y pagos.

## Características
- ✅ Gestión de clientes (CRUD)
- ✅ Gestión de tipos de préstamo (CRUD)
- ✅ Gestión de préstamos con generación automática de cuotas
- ✅ Cálculo automático de monto de cuota basado en monto, interés y plazo
- ✅ Gestión de cuotas (lista, ver detalle, eliminar)
- ✅ Gestión de pagos con actualización automática de estado de cuota
- ✅ Soporte para pagos parciales
- ✅ Actualización automática de estado de préstamo al completarse todas las cuotas
- ✅ Validaciones con Form Requests
- ✅ Lógica separada en Services
- ✅ Tests completos (PHPUnit)

## Endpoints de API

### Clientes
```
POST   /clientes              - Crear cliente
GET    /clientes              - Listar clientes
GET    /clientes/{id}         - Ver cliente
PATCH  /clientes/{id}         - Actualizar cliente
DELETE /clientes/{id}         - Eliminar cliente
```

### Tipos de Préstamo
```
POST   /tipos-prestamo        - Crear tipo de préstamo
GET    /tipos-prestamo        - Listar tipos de préstamo
GET    /tipos-prestamo/{id}   - Ver tipo de préstamo
PATCH  /tipos-prestamo/{id}   - Actualizar tipo de préstamo
DELETE /tipos-prestamo/{id}   - Eliminar tipo de préstamo
```

### Préstamos
```
POST   /prestamos             - Crear préstamo (genera cuotas automáticamente)
GET    /prestamos             - Listar préstamos
GET    /prestamos/{id}        - Ver préstamo con cuotas
PATCH  /prestamos/{id}        - Actualizar estado de préstamo
DELETE /prestamos/{id}        - Eliminar préstamo
```

### Cuotas
```
GET    /cuotas                - Listar cuotas
GET    /cuotas/{id}           - Ver cuota con pagos
DELETE /cuotas/{id}           - Eliminar cuota
```

### Pagos
```
POST   /pagos                 - Crear pago (actualiza estado de cuota)
GET    /pagos                 - Listar pagos
GET    /pagos/{id}            - Ver pago
DELETE /pagos/{id}            - Eliminar pago
```

## Ejemplos de Uso

### 1. Crear un Cliente
```bash
curl -X POST http://localhost:8000/clientes \
  -H "Content-Type: application/json" \
  -d '{
    "nombre": "Juan",
    "apellido": "Pérez",
    "ci": "12345678",
    "email": "juan@example.com",
    "telefono": "555-1234",
    "direccion": "Calle Principal 123"
  }'
```

### 2. Crear Tipos de Préstamo
```bash
curl -X POST http://localhost:8000/tipos-prestamo \
  -H "Content-Type: application/json" \
  -d '{
    "nombre": "Préstamo Personal",
    "interes": 5,
    "plazo": 12,
    "descripcion": "Préstamo con 5% de interés anual"
  }'
```

### 3. Crear un Préstamo (genera 12 cuotas automáticamente)
```bash
curl -X POST http://localhost:8000/prestamos \
  -H "Content-Type: application/json" \
  -d '{
    "cliente_id": 1,
    "tipo_prestamo_id": 1,
    "monto": 10000,
    "fecha": "2026-04-28"
  }'
```

**Respuesta:**
```json
{
  "id": 1,
  "cliente_id": 1,
  "tipo_prestamo_id": 1,
  "monto": "10000.00",
  "fecha": "2026-04-28",
  "estado": "activo",
  "created_at": "2026-04-28T03:30:00.000000Z",
  "updated_at": "2026-04-28T03:30:00.000000Z",
  "cuotas": [
    {
      "id": 1,
      "prestamo_id": 1,
      "numero": 1,
      "vencimiento": "2026-05-28",
      "monto": "875.00",
      "saldo": "875.00",
      "estado": "pendiente",
      "created_at": "2026-04-28T03:30:00.000000Z",
      "updated_at": "2026-04-28T03:30:00.000000Z"
    },
    ...
  ]
}
```

### 4. Registrar un Pago
```bash
curl -X POST http://localhost:8000/pagos \
  -H "Content-Type: application/json" \
  -d '{
    "cuota_id": 1,
    "fecha": "2026-04-28",
    "monto": 500,
    "metodo": "transferencia"
  }'
```

**Resultado:**
- La cuota cambia de "pendiente" a "parcial"
- El saldo de la cuota se reduce a 375

### 5. Pago Completo de Cuota
```bash
curl -X POST http://localhost:8000/pagos \
  -H "Content-Type: application/json" \
  -d '{
    "cuota_id": 1,
    "fecha": "2026-04-28",
    "monto": 375,
    "metodo": "efectivo"
  }'
```

**Resultado:**
- La cuota cambia de "parcial" a "pagada"
- El saldo de la cuota es 0
- Si todas las cuotas están pagadas, el préstamo cambia a "completado"

## Cálculo de Cuota

Formula: 
```
Monto Total = Monto Base × (1 + Interés/100)
Cuota Mensual = Monto Total / Plazo
```

Ejemplo:
- Monto: 10,000
- Interés: 5%
- Plazo: 12 meses

Cálculo:
```
Monto Total = 10,000 × 1.05 = 10,500
Cuota Mensual = 10,500 / 12 = 875
```

## Tests

Ejecutar todos los tests:
```bash
php artisan test --compact
```

Ejecutar tests específicos:
```bash
php artisan test --compact tests/Feature/ClienteTest.php
php artisan test --compact tests/Feature/PrestamoTest.php
php artisan test --compact tests/Feature/PagoTest.php
```

## Estructura del Código

```
app/
├── Http/
│   ├── Controllers/
│   │   ├── ClienteController.php
│   │   ├── TipoPrestamoController.php
│   │   ├── PrestamoController.php
│   │   ├── CuotaController.php
│   │   └── PagoController.php
│   └── Requests/
│       ├── StoreClienteRequest.php
│       ├── UpdateClienteRequest.php
│       ├── StoreTipoPrestamoRequest.php
│       ├── UpdateTipoPrestamoRequest.php
│       ├── StorePrestamoRequest.php
│       ├── UpdatePrestamoRequest.php
│       └── StorePagoRequest.php
├── Models/
│   ├── Cliente.php
│   ├── TipoPrestamo.php
│   ├── Prestamo.php
│   ├── Cuota.php
│   └── Pago.php
└── Services/
    └── PrestamoService.php

database/
├── migrations/
│   ├── 2026_04_28_033003_create_clientes_table.php
│   ├── 2026_04_28_033016_create_tipos_prestamo_table.php
│   ├── 2026_04_28_033017_create_prestamos_table.php
│   ├── 2026_04_28_033020_create_cuotas_table.php
│   └── 2026_04_28_033021_create_pagos_table.php
└── factories/
    ├── ClienteFactory.php
    ├── TipoPrestamoFactory.php
    ├── PrestamoFactory.php
    ├── CuotaFactory.php
    └── PagoFactory.php

tests/
└── Feature/
    ├── ClienteTest.php (7 tests)
    ├── PrestamoTest.php (6 tests)
    └── PagoTest.php (7 tests)
```

## Relaciones de Base de Datos

```
Cliente (1) ──────────── (n) Préstamo
TipoPrestamo (1) ──────── (n) Préstamo
Préstamo (1) ──────────── (n) Cuota
Cuota (1) ──────────── (n) Pago
```

## Convenciones Utilizadas

- ✅ Constructor Property Promotion (PHP 8)
- ✅ Type Hints explícitos en todas las funciones
- ✅ PHPDoc con tipos de retorno genéricos
- ✅ Form Requests para validaciones
- ✅ Services para lógica de negocio
- ✅ Modelos con relaciones Eloquent
- ✅ API responses en JSON
- ✅ Códigos de estado HTTP correctos (201 para creación, 200 para éxito, 422 para validación)
- ✅ Cascade delete en claves foráneas
