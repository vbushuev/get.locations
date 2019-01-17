## Task text

Need to implement Laravel bundle for getting JSON-encoded locations data stored in
predefined format.
Acceptance criteria
● Client should be defined as a service class in a bundle config;
● Client should utilize CURL as a transport layer (can rely upon any third-party bundle
however should be implemented as a separate class/package);
● Properly defined exceptions should be thrown on CURL errors, malformed JSON
response and error JSON response; locations format also should be validated;
● Resulting data should be fetched as an collection of properly defined PHP objects;
● Class dependencies should be injected via dependency injection;

JSON response format
<code>
{
    “data”: {
        “locations”: [
            {
                “name”: “Eiffel Tower”,
                “coordinates”: {
                    “lat”: 21.12,
                    “long”: 19.56
                }
            },
            ...
        ]
    },
    “success”: true
}
</code>
JSON error response format
<code>
{
    “data”: {
        “message”: &lt;string error message&gt;,
        “code”: &lt;string error code&gt;
    },
    “success”: false
}
</code>
