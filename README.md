# Todo Application

FILLEUL Mika & STAVRIDIS Adonis

---

## Introduction

This is a simple Todo list application made with PHP.

## Installation

Install the application by downloading or cloning this repository.

Then you need to run the following `todo.py` script to let it:

- install composer dependencies
- install node modules
- launch docker services
- launch application inside your browser

To run the script you can use the following command:

```bash
python3 todo.py
```

You can pass some arguments to the script:

- `-setup` to only install composer dependencies and node modules
- `-launch` to only launch docker services and application
- `-doc` to view the documentation
- `-test` to launch tests

When launching the application, your web browser should open a new window. If
you see any error message, such as 'Unable to connect' or 'Connection failed!'
refresh the page, until the docker is finished setting up.

Press `Ctrl + C` to terminate docker.

## Instructions

Information on how to use the app is available on the home page of the
application.

You can create a new account, or use the account with the following credentials:

- username : `root`
- password : `root`

## Work distribution

During this project FILLEUL Mika had a problem with his git program. So, for a
temporary time, he sent his files to STAVRIDIS Adonis and he pushed them to the
Git repository. Here is how the work was distributed :

FILLEUL Mika:

- Views
- Bootstrap
- Scss & css
- Documentation

STAVRIDIS Adonis

- Slim framework setup
- Models
- Controllers
- Ajax
- Search/Filter feature

In general the work was well distributed, we didn't hesitate to comment or
rectify each others work.
