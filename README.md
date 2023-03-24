# NDIS

## Queries

-   Referring to help desk
-   Discuss Xero

## Todo

-   Send verification mail button
-   Show for all models
-   Calculation of balance
-   Add button in claim to go to related allocation
-   Add button in allocation to go to related claims
-   Add button in claim index to show related allocations

## Users In The System

### Admin

    - Can create, edit, and delete staff.
    - Can verify and edit businesses and participants.
    - Can add and edit business and participant xero key.

### Staff

    - Can verify and edit businesses and participants.
    - Can add and edit business and participant xero key.

### Provider

    - Can create new businesses and participants
    - Create allocation agreements between businesses and participants
    - Need to verify their email to interact with the system

## Non-Users

### Participants

    - Will be created by providers
    - Will be verified by staff or admin

## Business

    - Will be created by providers
    - Will be verified by staff or admin
    - Must have a unique 11 digit ABN number

## Allocations (Needs Update)

-   Agreement between businesses and participants
-   Created by providers
-   First verified by staff
-   Then, verified by participant after staff sends them verification mail
-   The remaining amount will be calculated based on verified allocation of that participant and subtracting the sum from 1000
-   Max price charged depends on the item selected.


| Modules     | Description | Status  |
| ----------- | ----------- | ------- |
| Participant | Create      | Done    |
| Participant | Store       | Done    |
| Participant | Edit        | Done    |
| Participant | Update      | Done    |
| Participant | Show        | Pending |
| Participant | Verify      | Done    |
