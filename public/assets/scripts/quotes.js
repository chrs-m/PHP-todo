const quoteContainer = document.querySelector('.quote');
const quoteAuthor = document.querySelector('.author');

function generateQuotes() {
    fetch('https://type.fit/api/quotes')
        .then(function (response) {
            return response.json();
        })
        .then(function (data) {
            let randomInt = Math.floor(Math.random() * data.length);
            quoteContainer.innerText = '"' + data[randomInt].text + '"';
            if (data[randomInt].author !== null) {
                quoteAuthor.innerText = '- ' + data[randomInt].author;
            }
        });
}

quoteContainer.onload = generateQuotes();
