document.getElementById('chat-form').addEventListener('submit', function (e) {
    e.preventDefault();
    const message = document.getElementById('message').value;

    fetch('chat.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: `message=${encodeURIComponent(message)}`
    }).then(response => response.text())
      .then(data => {
          document.getElementById('chat-box').innerHTML = data;
          document.getElementById('message').value = '';
      });
});

setInterval(() => {
    fetch('chat.php')
        .then(response => response.text())
        .then(data => {
            document.getElementById('chat-box').innerHTML = data;
        });
}, 1000);