## Book Worm

PDF Book Summary API

## Pre-requisites
- **Docker running on the host machine.**
- **Basic knowledge of Docker.**
- **PHP 8.2**
- **PostgresSQL**

## Installation

1. Clone the repository and set up your .env file
```bash
git clone https://github.com/cFabricio23r/BookWorm.git
cp .env.example .env
```
Remember to set the needed environment variables in the .env file.
```bash
DB_CONNECTION=pgsql
DB_HOST={{host}}
DB_PORT=5432
DB_DATABASE={{database}}
DB_USERNAME={{username}}
DB_PASSWORD={{password}}

OPENAI_API_KEY={{openai_api_key}}
OPENAI_ORGANIZATION={{openai_organization}}
```
2. Build the docker container
```bash
docker build -t bookworm/api:bookworm .
```

3. Run the docker container
```bash
docker run --env-file .env -p 80:8000 -d --name bookworm bookworm/api:bookworm
```
## Documentation

[Postman Collection](https://www.postman.com/avionics-saganist-95143851/workspace/test/environment/26594612-7547afd1-260c-4a41-8253-a6aa0b71cb42)
