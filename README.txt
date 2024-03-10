After Activate
You will see News Custom Post Type in left side bar
Here you can Manage news and in News category you can manage category.

REST API

Method:-  POST
URL:-  {{baseUrl}}/wp-json/action/form-validation
Header :- Content-Type: application/json
Request Body :- {
   "email":"example@gmail.com",
    "phone":"1234567890" ,
    "url":"'https://www.example.com'"
}


here you can validate email,phone and Url. 

curl --location --request POST '{{baseUrl}}/wp-json/action/form-validation' \
--header 'Content-Type: application/json' \
--data-raw '{
   "email":"test@gmail.com",
    "phone":"1234567899" ,
    "url":"'https://www.example.com'"
}'
// Example data
{
   "email":"example@gmail.com",
    "phone":"1234567890" ,
    "url":"'https://www.example.com'"
}

Once These are fine data saved to records Table.


You can see data in Table and by this get api also

Method Get
Url :- {{BaseUrl}}/wp-json/action/form-data


curl --location --request GET 'http://localhost/test/wp-json/action/form-data'
