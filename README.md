# BnB platform
---

## Description


This project is a platform for booking rooms in a BnB. This project is build with my student in the context of a course of a web development path.

The technologies used are:

Symfony 7
Bootstrap 5
Twig
MySQL

## Entities
---

### User

This entity represents a user of the platform. The user can be a traveler or a host. They are defined by the ```role``` property.

| Property   | Type      | Description          | Relationship |
|------------|-----------|----------------------|--------------|
| email      | string    | 180 NOT NULL, UNIQUE |              | 
| password   | string    | 255 NOT NULL         |              | 
| firstname  | string    | 50 NOT NULL          |              | 
| lastname   | string    | 50                   |              |
| role       | string    | 50 NOT NULL          |              |
| image      | string    | 255                  |              |
| address    | string    | 255                  |              |
| city       | string    | 50                   |              |
| country    | string    | 50                   |              |
| created_at | datetime  | NOT NULL             |              |
| rooms      | ManyToOne |                      | Room         | 
| bookings   | OneToOne  |                      | Booking      | 
| reviews    | OneToOne  |                      | Reviews      |

---

### Room

This entity represents a room for rent.

| Property    | Type       | Description          | Relationship |
|-------------|------------|----------------------|--------------|
| title       | string     | 50 NOT NULL, UNIQUE  |              | 
| description | text       | NOT NULL             |              | 
| price       | integer    | NOT NULL             |              | 
| address     | string     | 255                  |              |
| city        | string     | 50                   |              |
| country     | string     | 50                   |              |
| created_at  | datetime   | NOT NULL             |              |
| host        | ManyToOne  | NOT NULL, OrphanTrue | Room         | 
| bookings    | OneToOne   |                      | Booking      | 
| reviews     | OneToOne   |                      | Reviews      |
| equipments  | ManyToMany |                      | Equipment    |

---

### Review

This entity represents a review made by traveler to a booking for a room.

| Property   | Type      | Description          | Relationship |
|------------|-----------|----------------------|--------------|
| title      | string    | 50 NOT NULL          |              | 
| comment    | text      | NOT NULL             |              | 
| rating     | integer   | NOT NULL             |              | 
| created_at | datetime  | NOT NULL             |              | 
| traveler   | ManyToOne | NOT NULL, OrphanTrue | User         | 
| room       | ManyToOne | NOT NULL, OrphanTrue | Room         | 
| booking    | OneToOne  | NOT NULL, OrphanTrue | Booking      | 

---

### Booking

This entity represents a booking made by traveler for a room.

| Property   | Type      | Description          | Relationship |
|------------|-----------|----------------------|--------------|
| number     | string    | 50 NOT NULL          |              | 
| check_in   | datetime  | NOT NULL             |              | 
| check_out  | datetime  | NOT NULL             |              | 
| occupants  | integer   | NOT NULL             |              |
| created_at | datetime  | NOT NULL             |              | 
| traveler   | ManyToOne | NOT NULL, OrphanTrue | User         | 
| room       | ManyToOne | NULL, OrphanTrue     | Room         | 
| review     | OneToOne  | NULL, OrphanTrue     | Review       |

---

### Equipment

This entity represents the equipment for a room.

| Property  | Type       | Description | Relationship |
|-----------|------------|-------------|--------------|
| name      | string     | 50 NOT NULL |              | 
| rooms     | ManyToMany |             | Room         | 

---

## Pages architecture

-- paris, kyoto, las vegas, sydney, hong kong -- all rooms -- room -- booking -- payment -- login -- register -- account
-- my rooms -- new room -- edit room -- my bookings -- booking -- my reviews -- review