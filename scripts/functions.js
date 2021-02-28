let isItOpen = false

let url = new URL(window.location);
let searchParams = new URLSearchParams(url.search);

const debounce_search = _.debounce( s => call_api_results(s), 300, {})

const call_api_results = search_term => {
    console.log("Fetching results for: ", search_term)

    document.getElementById('clear').style.visibility = "visible"
    if (search_term === "") {
        clear_searchbar()
        return
    }

    fetch(`http://www.omdbapi.com/?s=${search_term}&apikey=${config.omdb_key}`)
    .then(x => x.json() )
    .then(y => {
        document.getElementById('search_results').innerHTML = ""
        
        if(y.Response === "True"){
            document.getElementById('search_results').style.display = "block"

            y.Search.map(movie => {
                const p = document.createElement('p')
                p.innerHTML = `${movie.Title} (${movie.Year})`

                const div = document.createElement('div')
                div.onclick = () => {
                    clear_searchbar()
                    document.getElementById('search_results').style.display = "none"
                    goToMovie(movie.imdbID) 
                }
                div.appendChild(p)
                document.getElementById('search_results').appendChild(div)
            })
        }else {
            document.getElementById('search_results').style.display = "none"
        }
    }).catch(error => {
        console.warn("ERROR: ",error);
    })
}

const activate_review_post_btn = review => {
    if (review === "") { 
        document.getElementById('post_review_btn').disabled = true
        return 
    }
    document.getElementById('post_review_btn').disabled = false
}