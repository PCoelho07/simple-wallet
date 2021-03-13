# Simple Wallet API

## Transactions

Used to make a transfer between two account users

**URL** : `/api/transactions`

**Method** : `POST`

**Auth required** : YES

**Permissions required** : `user` role

**Data constraints**

```json
{
    "value": "[float number greater than zero]",
    "payer": "[integer number greater than zero]",
    "payee": "[integer number greater than zero]"
}
```

**Data example**

```json
{
    "value": 10.50,
    "payer": 1,
    "payee": 2
}
```

## Success Response

**Code** : `200 OK`

**Content example**

```json
{
  "success": true,
  "data": {
    "user_source_id": 1,
    "user_target_id": 2,
    "value": 10.5,
    "status": "success",
    "hash_signature": "$2y$10$Q1v4hLOL4Fp9rTF7eX0tJ.etCoc3G.gAfkp1ADk8Hg93JGEQ2B\/Yy",
    "updated_at": "yyyy-mm-dd hh:mm:ss",
    "created_at": "yyyy-mm-dd hh:mm:ss",
    "id": 4
  }
}
```

## Error Response

**Condition** : If user is unauthenticated

**Code** : `401 Unauthorized`

**Content** :

```json
{
  "message": "Unauthenticated."
}
```

**Condition** : If user has not the role "`user`"

**Code** : `403 Forbidden`

**Content** :

```json
{
  "message": "This action is unauthorized.",
}
```

**Condition** : If payload is not valid.
* `payer` or `payee` not exists
* the value of transaction is greater than `payer` has in wallet.
* all of kind of errors

**Code** : `400 Bad Request`

**Content** :

```json
{
  "success": false,
  "error": "Can not store the resource!"
}
```
