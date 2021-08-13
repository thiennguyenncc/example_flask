# Authentication


## Admin


> Example request:

```bash
curl -X POST \
    "http://bachelor.local/oauth/token" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"grant_type":"password","client_id":1,"client_secret":"AcprVuRwWWOpDGRkaQDlvFuvmQFY2LR52oTiu5g2","provider":"admin","username":"admin@xvolve.com","password":"pa$$word","scope":"*"}'

```

```javascript
const url = new URL(
    "http://bachelor.local/oauth/token"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "grant_type": "password",
    "client_id": 1,
    "client_secret": "AcprVuRwWWOpDGRkaQDlvFuvmQFY2LR52oTiu5g2",
    "provider": "admin",
    "username": "admin@xvolve.com",
    "password": "pa$$word",
    "scope": "*"
}

fetch(url, {
    method: "POST",
    headers: headers,
    body: body
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (200):

```json
{
    "token_type": "Bearer",
    "expires_in": 31536000,
    "access_token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJhdWQiOiIxIiwianRpIjoiMzFjYzAxMmQ0NDM2OTBkZTVhNDlmM2NiODk3OTFjZWRiMDlhZTViOTRkOWM2MjNiYTRkOTBkZDMxN2Y4OGI3MmUxOGQ4ZDQyMWMyNzkyYzEiLCJpYXQiOjE2MDYxMTk0MTUsIm5iZiI6MTYwNjExOTQxNSwiZXhwIjoxNjM3NjU1NDE1LCJzdWIiOiIxIiwic2NvcGVzIjpbXX0.pYC3MIqABX2zQULbUm-zmEigqpvS2G8Livi7D__kvHBSV2hW-D2l5vJikWv0XVxPj-G5e8U_4Wzr2hX_bGkS7XzJDfSWvOUxRejGtGtB0a5G0wo6hY5J7VJlRkpKfLA65ywBFMSbKLn5AWLbyTAyrmxuUXsh4GF-ShziWmG2DWcN9T1OrittUBQ_jahpc5IRxivYMtmYeMFfQC5Kax1V6TdqTMS6KZWJ1-MqMIIr0-HzjwXc2xyFK1FCjh7xdcYYLtr3N8KgQBOOIMbXnyw13bsAu2TSRcferMlW16Fesqas_I89EH7-Wh5s8A7rmDcwlesT1spr9-QUVKbH2LQXcjAgZPtKKmVfpSPiAOeKfYiK-zG3NwMBgQ6JUhp_MzP5jjVBi7lsWa-hG_4qrqv2CsZoGpa_ns_ZSaNSiD08ZNetSsQMkvZQm_rxH5_gnVrNnUFE_ccMrYDEz_JwOeQv64q99gJF0-0NOp4UMItVRDEBaEP5yz0BOnuXWuguwRGYoKCQZDvIcmQUysM2retwG9r59ffJeOuUqedGqibbtZYw0m2PnfOyi02zFaPKsMUhLe01nFILGNA9z959uoQuAT8FTViuf1_wfxqrKSE3W189SZO51maW66pj0sVw3_HrTqCdMIcQnqEVS_BxdXx6mqet2DnbmpEWUoHm2niHKhU",
    "refresh_token": "def5020050607e944323208ed0fc7e4a77c80d1d41c4f7a96a6d797e762d83bebcc85c5cde2d2c88d04b9fdd2513875db10bf5f52d60d5d00a6a44178671f96bd4dc387986a72243b47fe2e6b556ed2e82c65fb3616ca28d48c823a0a66ba762a560f6a8475c69e08919def533bde3d669684f6a771d919c65861a345519b67759032e50021b1f87c7e6a2583a9fc84c7d49d959103ffc575631d9d3adf1c3e679c620abb4cdd1a6c688f85eb90138a916eb8922f7ac646e84b7ad12692e6d9d5916f01aed9bc5983f3128a55da8d4b1e252b88f277e6e0e44ae09faa6529dc7c1b4078e7d48b47065bc63b4b151727fc4c571cdbc4f58f580a74a79abea53e7e9892de5ae6bc52a895f6a80ec1339ce45b380427b9f371789a9286d8eb807ba248cb445472342b5281420681780705cc949f9f8b708e62776e9bab5b6b9881acfc1c5b73078372e1dbeae011725db938f279db57f01082191989f5d4439bfb8ce"
}
```
> Example response (400):

```json
{
    "error": "invalid_grant",
    "error_description": "The provided authorization grant (e.g., authorization code, resource owner credentials) or refresh token is invalid, expired, revoked, does not match the redirection URI used in the authorization request, or was issued to another client.",
    "hint": "",
    "message": "The provided authorization grant (e.g., authorization code, resource owner credentials) or refresh token is invalid, expired, revoked, does not match the redirection URI used in the authorization request, or was issued to another client."
}
```

### Request
<small class="badge badge-black">POST</small>
 **`oauth/token`**

<h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
<code><b>grant_type</b></code>&nbsp; <small>string</small>     <br>
    Set to 'password'.

<code><b>client_id</b></code>&nbsp; <small>integer</small>     <br>
    The client ID provided.

<code><b>client_secret</b></code>&nbsp; <small>string</small>     <br>
    The client secret.

<code><b>provider</b></code>&nbsp; <small>string</small>     <br>
    Set to 'admin'.

<code><b>username</b></code>&nbsp; <small>string</small>     <br>
    Username or email.

<code><b>password</b></code>&nbsp; <small>string</small>     <br>
    The admin password.

<code><b>scope</b></code>&nbsp; <small>string</small>         <i>optional</i>    <br>
    Can be empty or '*'.


