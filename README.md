# MovieReviewer

### This project was an assignment for the University class of WWW Technologies.

</br>

## Details

So the instructions was to create a web site that had basic HTML structure, CSS styling and a client side as well as server side functionality.

Also 
 - It needed to support responsive design 
 - Be secure against
    - Broken authentication & session management ­ 
    - Security misconfiguration ­ 
    - SQL Injections
- Have three levels of access
    - Guest ( No extra rights )
    - User ( Basic level of access )
    - Administrator ( Full control over the users )

Extra points would be awarded if we fetch data from an API to fill the database with and if there was an throttling or debounce implementation on that API call.

</br>

## The Project 

</br>

The idea for this site was that it would be a service for writting reviews on movies you have watched.

</br>

#### TECHNOLOGIES USED

> [PHP](https://www.php.net/index.php) </br>
> [MySQL](https://www.mysql.com/) </br>
> [Lodash](https://lodash.com/) </br>

> [OMDb API](http://www.omdbapi.com/) </br>

</br>

#### USER

Users can search for movies and get some basic information about them, add them to their watchlist and of course reviewed them. 

#### ADMIN

Admins can do all the things a regular user can but they can also delete users, create new users or promote them from simple users to admins and vice versa.

#### GUEST

Guests can only browse through the site and search for movies and see the reviews others have written for the movie searched.

</br>

## Authors


[Roussos Ioannis](https://github.com/JRoussos) </br>
[Lalis Dimitrios](https://github.com/dlalis)


</br>

## License

</br>

Copyright (c) 2021 John Roussos

Permission is hereby granted, free of charge, to any person obtaining a copy of this software and associated documentation files (the "Software"), to deal in the Software without restriction, including without limitation the rights to use, copy, modify, merge, publish, distribute, sublicense, and/or sell copies of the Software, and to permit persons to whom the Software is furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.