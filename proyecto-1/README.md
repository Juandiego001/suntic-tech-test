# Proyecto 1

## Modelado relacional

```mermaid
erDiagram
clients {
    bigint line PK
    bigint document UK
    varchar(30) document_type
    varchar(50) name
    varchar(30) city
    varchar(60) email 
}

contracts {
    bigint code PK
    bigint client_line PK, FK
    date activated_at
    bigint price
    varchar(30) status 
}

payments {
    bigint id PK "AUTO_INCREMENT"
    bigint contract_code PK, FK
    bigint amount
    timestampt created_at
}

clients ||--o{ contracts : has
contracts ||--o{ payments : has
```

## Componentes utilizados en el frontend

Se utilizaron algunos componentes de ejemplos del bootstrap para agilizar el diseño:
- https://getbootstrap.com/docs/5.3/examples/grid/
- https://getbootstrap.com/docs/5.3/examples/heroes/
- https://getbootstrap.com/docs/5.3/examples/headers/
- https://getbootstrap.com/docs/5.3/examples/dashboard/
- https://getbootstrap.com/docs/5.3/examples/modals/
- https://getbootstrap.com/docs/5.3/examples/checkout/