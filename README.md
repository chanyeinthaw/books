# Book Catalog

Book Catalog is a web application in which users can create, update, delete their books and export their catalog in `csv` or `xml` format.

## Technologies

- Laravel
- Inertia (React)
- Docker

## Usage 

- install `docker` and `docker-compose`.
- `clone` this repository.
- change directory to `books`.
- run `docker-compose up`.

## Project Structure

The project directory structure is the same as Laravel's default structure plus these directories - 

| Directory         | Description                               |
|-------------------|-------------------------------------------|
| lib               | For user created libraries and utilities. |
| app/UseCases      | For application's business logics.        |
| app/Http/Handlers | For HTTP route handlers.                  |


## Routes

| Method | URI        | Description      |
|--------|------------|------------------|
| GET    | /          | Book list        |
| GET    | /{id}      | Book page        |
| DELETE | /{id}      | Delete book API  |
| GET    | /create    | Create book page |
| POST   | /create    | Create book API  |
| GET    | /{id}/edit | Updaet book page |
| PATCH  | /{id}/edit | Update book API  |
| GET    | /export    | Book export API  |