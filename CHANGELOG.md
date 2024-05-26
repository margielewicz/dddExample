    Added
    OrderController
    Implementation of OrderController with the following endpoints:
    
    Create Order
        Endpoint: POST /order
        Description: This endpoint allows the creation of a new order.
        Request Payload:

    {
        "items": [
        {
            "product_id": 1,
            "quantity": 1
        },
        {
            "product_id": 2,
            "quantity": 1
        }
        ]
    }

        Response:
        Success (200): Returns the details of the created order.
        Error (400): Returns an error message if the input is invalid or if an exception occurs.

    Get Order
        Endpoint: GET /order/{id}
        Description: This endpoint retrieves the details of an existing order by its ID.
        Path Parameter:
        id: The ID of the order to retrieve.
        Response:
        Success (200): Returns the details of the requested order.
        Error (404): Returns an error message if the order is not found.

    Notes
    The .env file has been included to provide example configurations.