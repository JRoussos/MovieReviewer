const goToHome = () => {
    // document.getElementById('home').submit();
    document.location.search = 'page=home';
}

const goToReviews = () => {
    // document.getElementById('reviews').submit();
    document.location.search = 'page=reviews';
}

const goToWatched = () => {
    // document.getElementById('watchlist').submit();
    document.location.search = 'page=watchlist';
}

const goToUserList = () => {
    document.location.search = 'page=tools';
}

const logOut = () => {
    document.location.search = 'logout=1';
    // window.location.replace("index.php?logout='1'")
}

const goToMovie = id => {
    value = encodeURIComponent(id);
    document.location.search = `id=${value}`;
}

const toggle_sidebar = () => {
    isItOpen = !isItOpen
    document.getElementById('background_sidenav').classList.toggle('hidden')
    document.querySelector('.sidenav').style.left = isItOpen ? "0" : "-250px"
}

const clear_searchbar = () => {
    document.getElementById('input_field').value = ''
    document.getElementById('clear').style.visibility = "hidden"
    document.getElementById('search_results').style.display = "none"
}

const add_to_watchlist = () => {
    // document.getElementById('add_to_watchlist_btn').classList.toggle('is_on_watchlist')   
}

const edit_review = commentID => {
    const parent = document.getElementById(commentID);

    const paragraph = parent.getElementsByTagName('p')[0];
    const div = parent.getElementsByTagName('div')[0];

    const form = document.createElement('form');
    const wrapper = document.createElement('div');
    const backdrop = document.createElement('div');
    const textarea = document.createElement('textarea');
    const ready_btn = document.createElement('button');
    const cancel_btn = document.createElement('div');

    ready_btn.className = "edit"
    ready_btn.innerHTML = "save"
    ready_btn.value = commentID
    ready_btn.name = "edit_review_btn"
    ready_btn.style.height = "40px"
    ready_btn.style.zIndex = "1"

    cancel_btn.className = "cancel_btn"
    cancel_btn.onclick = () => {
        parent.replaceChild(div, form)
    }

    backdrop.className = "backdrop"

    wrapper.className = "textarea_wrapper"
    
    textarea.innerHTML = paragraph.innerHTML
    textarea.name = "edit_review_textarea"
    
    form.className = "btn_wrapper"
    form.method = "post"
    form.style.flexDirection = "column"
    
    wrapper.appendChild(textarea)
    form.appendChild(backdrop)
    form.appendChild(cancel_btn)
    form.appendChild(wrapper)
    form.appendChild(ready_btn)

    parent.replaceChild(form, div)
}

const edit_user = userID => {
    const prevEl = document.getElementById(userID)
    if(!prevEl){ return }

    const row = document.createElement('td');
    const form = document.createElement('form');
    const cancel_btn = document.createElement('button');

    form.method = "post"
    form.style = "min-width: max-content"
    form.innerHTML = `<select name="edit_user_type" style="margin: 0; padding: 5px 15px;" >
                        <option value="user">User</option>
                        <option value="admin">Admin</option>
                    </select>
                    <button name="edit_user_btn" value=${userID} style="outline: none; border: none; background: none; padding: 0 0 0 15px;">✔️</button>`

    cancel_btn.className = "cancel_user_edit_btn"
    cancel_btn.type = "button"
    cancel_btn.innerHTML = "❌"
    cancel_btn.onclick = () => {
        row.parentNode.replaceChild(prevEl, row)
    }

    form.appendChild(cancel_btn)
    row.appendChild(form)

    prevEl.parentNode.replaceChild(row, prevEl)
}