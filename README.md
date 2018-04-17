# Url Shortener

This is a simple, preliminary URL shortening web application. Input a full url, even the query string, and convert long URLs to short ones. 

# Install

1. Update /shorten/settings.php with the correct database creds
   - The variable USEABLE_CHARS can be updated to use any URL safe characters. 
     - NOTE: Adding a period will make it so index.php will at some point be used. There is no error handling for this.
2. Create the database table from the table.sql file provided


