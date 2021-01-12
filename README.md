# id
ID-portal for UKM.no

![Midlertidig flytskjema](Flytskjema.png?raw=true)
[rediger flytskjema](https://app.diagrams.net/)



# API
## Authenticate

Authenticate from client

```http
GET /api/authenticate.php
```

| Parameter | Type | Description |
| :--- | :--- | :--- |
| `nonce` | `string` | **Required**. key generated from client |

### Responses


```javascript
{
  "returnTo" : string,
  "state"    : string,
  "code"     : string
}
```

The `returnTo` attribute ...

The `state` attribute describes ...

The `code` attribute contains ...

### Status Codes

Gophish returns the following status codes in its API:

| Status Code | Description |
| :--- | :--- |
| 200 | `OK` |
| 201 | `CREATED` |
| 400 | `BAD REQUEST` |
| 404 | `NOT FOUND` |
| 500 | `INTERNAL SERVER ERROR` |

