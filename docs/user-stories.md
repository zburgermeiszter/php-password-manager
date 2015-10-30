# Password manager

Implement simple password manager system.

# Architecture

An SPA (single page applcation) is loaded into the browser and it is communicating with a REST API
Content Type: JSON
Transport method: XHR (ajax)

Users should be able to login, but registration facility has not been requested by the product owner.

User login password must be encrypted in a one-way encryption.
Saved passwords must be encrypted with a two-way encryption using user login password as a secret key.
If the user forget his password, there's no way to recover his data.

It must use wrappers for session, database, config.


It should implement the middleware pattern.
Database is a singleton implemented in trait.


Request and response objects.