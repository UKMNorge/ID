# id
ID-portal for UKM.no

![Midlertidig flytskjema](Flytskjema.png?raw=true)
[rediger flytskjema](https://app.diagrams.net/)



# API

## Authorization

Authorization of a client by providing credentials of the client

```http
POST /api/auth.php
```

| Parameter | Type | Description | Accepted values
| :--- | :--- | :--- | :----|
| `grant_type` | `string` | **Required**. Type of the grant | 'password'
| `client_id` | `string` | **Required**. Client id |
| `client_secret` | `string` | **Required**. Client secret |
| `return_to` | `string` | **Required**. The url of the client to redirect the user |


### Response

```javascript
{
    'expires_in'    : 'int',
    'scope'         : 'string',
    'token_type'    : "Bearer",
    'return_to'     : 'string',
    'code'          : 'string'
}
```
`return_to` the link where the user should be redirected\
`expires_in` how much time the authorization is available\
`scope`\
`token_type`



## Verify Access Token

Verify the access token after the user delivers the `code` to client

```http
POST /api/verify-access-token.php
```

| Parameter | Type | Description
| :--- | :--- | :--- | 
| `code` | `string` | **Required**. code generated by ID  |


### Response

```javascript
{
    'access_token' : 'string',
}
```
`access_token` token generated by authenticate. It can be used to validate the authentication process afterwards



# Status Codes Description 

| Status Code | Description |
| :--- | :--- |
| 200 | `OK` |
| 201 | `CREATED` |
| 400 | `BAD REQUEST` |
| 401 | `UNAUTHORIZED` |
| 403 | `UNAUTHORIZED - you don’t have permission access on this server` |
| 404 | `NOT FOUND` |
| 500 | `INTERNAL SERVER ERROR` |

