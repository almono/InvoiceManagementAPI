
## Setup Instructions:

* Start the project by running `./start.sh`.
* To access the container environment, use: `docker compose exec app bash`.

I added Swagger UI for easier endpoint testing which can be found under http://localhost/api/documentation once the docker container is started.

The Invoice and Notification logic has been split between two modules.

Invoice module is responsible for creating the invoice with given parameters, getting data on the stored invoices.

CreateInvoiceRequest class has been implemented as a way to validate the sent payload. 
It validates each field sent during invoice creation as well as product lines ( if they are present ) to make sure the values are set correctly.

During Invoice generation if the product line json is valid we make sure the product lines have unique uuids which then can be attached to the main Invoice model.
Because this process has more than one step I decided to use a transaction to confirm whether or not the creation of all objects ended successfully.

When sending a request for Invoice information if the invoice exists and it contains product lines it should return it along with calculated sum of all the products.

Sending notification ( Invoice ) is done in a Notification module where we confirm the Invoice status first, if it is correct then we create a notification data object with
data used for the email that is sent right after. Once the email is sent the Invoice status is updated to "sending" and an event is being prepared to handle the delivery of that email,
once the email is delivered the Invoice status is updated to "sent-to-client".

For tests I decided to do a simple unit tests that check for valid and invalid invoice creation as well as checking the view endpoint.