const quoteContainer = document.querySelector('.quote-container');
const quoteAuhtor = document.querySelector('.quote-auhtor');

function generateQuotes() {
    fetch('https://type.fit/api/quotes')
        .then(function (response) {
            return response.json();
        })
        .then(function (data) {
            let randomInt = Math.floor(Math.random() * data.length);
            quoteContainer.innerText =
                data[randomInt].text + '\n - ' + data[randomInt].author;
        });
}

quoteContainer.onload = generateQuotes();
