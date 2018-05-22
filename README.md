# Symfony 4 Auth

This project is a "proof of concept" to demonstrate how to build an authentication system with Symfony 4 using no dependencies (such as FOSUserBundle).

It covers the following features :

- User registration, automatically logging the user and redirecting him to home page with a flash message
- User login with email
- Remember me option available on the login form
- Automatically sets up the user's created_at timestamp upon registration using Doctrine Lifecycle events
- Listener to prevent the user to go back to anonymous pages when logged in
- Listener to automatically update user's last login timestamp upon every successfull authentication
- Assets management with [@symfony/webpack-encore](https://symfony.com/doc/current/frontend.html) 

### Live demo

<https://symfony4-auth.frank-fidanza.fr/>



