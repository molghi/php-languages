<script>
    // submit POST form to some page
    function submitPostForm(actionString) {      
        const form = document.createElement("form"); form.method = "POST";
        form.action = actionString;
        document.body.appendChild(form); form.submit();
    }

    // =========================================================================================================

    if (document.querySelector('.entries')) {
        document.querySelector('.entries').addEventListener('click', function(e) {
            // REACT TO CLICKING DELETE BTN
            if (!e.target.closest('.delete-entry') && !e.target.closest('.edit-entry')) return;
            const closestEntry = e.target.closest('.entry');
            if (e.target.closest('.delete-entry')) {
                // delete word
                const word = closestEntry.querySelector('.entry-word').textContent.trim();
                console.log(word)
                const lang = closestEntry.querySelector('.entry-lang').textContent.trim();
                const answer = confirm(`Are you sure you want to delete this entry?\n\n${word}\nLanguage: ${lang}\n\nThis action cannot be undone.`);
                if (!answer) return;
                const wordId = closestEntry.dataset.wordId;
                console.log(`delete ${wordId}`);
                submitPostForm(`../public/index.php?action=deleteword&wordid=${wordId}`);
            } else {
                // edit word
                const wordId = closestEntry.dataset.wordId;
                location.href = `../public/form.php?action=edit&wordid=${wordId}`;
            }
        })
    }

    // =========================================================================================================

    function toggleRegBtn () {
        const numOfRounds = document.querySelectorAll('.entry').length;
        const numOfCheckedInputs = document.querySelectorAll('input[type="radio"]:checked').length;
        if (numOfCheckedInputs < numOfRounds) {
            document.querySelector('.btn-reg-results').disabled = true;
            document.querySelector('.btn-reg-results').classList.add('opacity-50', 'cursor-not-allowed');
            if (document.querySelector('.reg-msg')) document.querySelector('.reg-msg').remove();
            document.querySelector('.btn-reg-results').insertAdjacentHTML('afterend', '<span class="reg-msg font-mono text-green-500 ml-6">Test your knowledge on each question to register your results.</span>')
        } else {
            document.querySelector('.btn-reg-results').disabled = false;
            document.querySelector('.btn-reg-results').classList.remove('opacity-50', 'cursor-not-allowed');
            if (document.querySelector('.reg-msg')) document.querySelector('.reg-msg').remove();
        }
    }

    if (document.querySelector('.btn-reg-results')) {
        toggleRegBtn();

        document.querySelector('.entries').addEventListener('click', function(e) {
            if (!e.target.closest('.peer')) return;
            toggleRegBtn();
        })
    }

    // =========================================================================================================

    if (document.querySelector('.btn-log-out')) {
        document.querySelector('.btn-log-out').addEventListener('click', function(e) {
            const answer = confirm('Are you sure you want to log out?');
            if (!answer) return;
            submitPostForm(`../public/index.php?action=logout`);
        })
    }

    // =========================================================================================================

    if (document.querySelector('.auth')) {
        const loginTab = document.getElementById('loginTab');
        const signupTab = document.getElementById('signupTab');
        const loginForm = document.getElementById('loginForm');
        const signupForm = document.getElementById('signupForm');

        loginTab.addEventListener('click', () => {
            // Show login form, hide signup
            loginForm.classList.remove('hidden');
            signupForm.classList.add('hidden');

            // Update tab styles
            loginTab.classList.add('bg-green-900', 'text-green-200');
            loginTab.classList.remove('bg-black', 'hover:bg-green-900');
            signupTab.classList.add('bg-black', 'hover:bg-green-900');
            signupTab.classList.remove('bg-green-900', 'text-green-200');
        });

        signupTab.addEventListener('click', () => {
            // Show signup form, hide login
            signupForm.classList.remove('hidden');
            loginForm.classList.add('hidden');

            // Update tab styles
            signupTab.classList.add('bg-green-900', 'text-green-200');
            signupTab.classList.remove('bg-black', 'hover:bg-green-900');
            loginTab.classList.add('bg-black', 'hover:bg-green-900');
            loginTab.classList.remove('bg-green-900', 'text-green-200');
        });

    }

    // =========================================================================================================

    async function getCategories (value) {
        let res = await fetch(`../public/index.php?action=getcategories&input=${value}`);
        res = await res.json();
        return res;
    }

    function fillCategoryField () {
        if (document.querySelector('.fetched-categories')) {
            document.querySelector('.fetched-categories').addEventListener('click', function (e) {
                if (!e.target.closest('.fetched-category')) return;
                const categoryText = e.target.closest('.fetched-category').textContent;
                document.querySelector('input[name="category"]').value = categoryText;
                document.querySelector('input[name="category"]').focus();
            })
        }
    }

    function renderCategories (fetchedResult) {
        if (document.querySelector('.fetched-categories')) document.querySelector('.fetched-categories').remove();
        if (fetchedResult.length === 0) return;
        const categories = fetchedResult.map(x => '<li class="whitespace-nowrap underline fetched-category cursor-pointer hover:no-underline active:opacity-80 mb-1">' + x.category.replaceAll('_', ' ') + '</li>').join();
        document.querySelector('.category-block').insertAdjacentHTML('beforeend', `<div class="absolute top-[5px] left-[120%] fetched-categories">
        <div class="whitespace-nowrap text-[coral] mb-1">Added before:</div>
        <ul class="list-disc pl-5">
            ${categories}
        </ul>
        </div>`)
    }

    if (document.querySelector('input[name="category"]')) {
        const catInput = document.querySelector('input[name="category"]');
        catInput.addEventListener('input', async function(e) {
            const inputValue = e.target.value.trim();
            if (inputValue.length > 1) {
                const fetchedResult = await getCategories(inputValue);
                renderCategories(fetchedResult);
            }
            fillCategoryField();
        })
    }

</script>