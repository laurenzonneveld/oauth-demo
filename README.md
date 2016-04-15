# Oauth2 demo

## Terminology
**grant type:** Oauth2 uses different flows for authorization<br />
**resource server:** Server where the protected user data resides, for example a userprofile on Facebook<br />
**client application:** Application which want to access the protected data on behalf of the user<br />
**authorization server:** Server which holds user account data<br />
**client id:** ...<br />
**client secret:** ...<br />
**scope:** ...<br />
**authorization code** ...<br />
**access token:** ...<br />

The **resource server** and **authorization server** can be the same server/domain using different endpoints, for example _domain.com/authorization/_ and _domain.com/api/_

## Flow
### Granttype authorization_code

The client application needs users to be registered but does not want to force a new user to fill in a profile which they have already filled for gazillion other websites.

The client application wants to act on behalf of its user, for example post messages on Twitter of Facebook.

1. User chooses to give your **client application** access by clicking a link like _Login with Facebook_.
2. **Client application** redirects the user to the **authorization server** supplying  **client id** and **scope** in the request. This lets the **authorization server** know which application wants access and which permissions is wants.
3. **Authorization server** checks whether the client application is valid and is allowed to request the supplied permissions.
When valid, the **authorization server** serves the user a page showing which application want to access and which permissions it wants. The user can then accept or reject this. When accepted, the **authorization server** redirects the user back to the **client application** with an **authorization code**.
4. ...store and retrieve access token
5. The **client application:** can now access protected resource or act on behalf of the user by doing a request to the **resource server** with the **access token** supplied. The token is usually supplied via an authorization header, ```Authorization: Bearer {{token}}```.
