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
                const word = closestEntry.querySelector('.entry-word').textContent;
                const lang = closestEntry.querySelector('.entry-lang').textContent;
                const answer = confirm(`Are you sure you want to delete this entry?\n\nWord: ${word}\nLang: ${lang}\n\nThis action cannot be undone.`);
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

</script>