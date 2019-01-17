## Task text

Need to implement Laravel bundle for getting JSON-encoded locations data stored in
predefined format.
Acceptance criteria
<ul>
<li>Client should be defined as a service class in a bundle config;</li>
<li>Client should utilize CURL as a transport layer (can rely upon any third-party bundle however should be implemented as a separate class/package);</li>
<li>Properly defined exceptions should be thrown on CURL errors, malformed JSON response and error JSON response; locations format also should be validated;</li>
<li>Resulting data should be fetched as an collection of properly defined PHP objects;</li>
<li>Class dependencies should be injected via dependency injection;</li>

<p>
JSON response format
<pre>
<code>
{
    “data": {
        “locations": [
            {
                “name": “Eiffel Tower",
                “coordinates": {
                    “lat": 21.12,
                    “long": 19.56
                }
            },
            ...
        ]
    },
    “success": true
}
</code>
</pre>
</p>
<p>
JSON error response format
<pre>
<code>
{
    “data": {
        “message": &lt;string error message&gt;,
        “code": &lt;string error code&gt;
    },
    “success": false
}
</code>
</pre>
</p>
