THIS IS A WORK IN PROGRESS

symfony-backbone-spa
====================

This codebase serves as a Proof of concept and playground for a single page app with a Symfony back-end and a Backbone front-end. The main idea is that the front-end should be separated from the back-end as much as possible. The back-end should only expose an API, returning JSON or XML.
Advantages of this approach:
- Both are interchangeable.
	- E.g. Backbone could be replaced by AngularJS
	- E.g. We could add a NodeJS server between Backbone and Symfony
- Separated deployment / Continious integration, with the tools best suited for 1 technologie.
- Parallel programming in other languages. Both back-end and front-end can have a specialist in that language.

