/*
 Author: Akshaya Bhandare 
 Page: Main Javascript code  to stimulate
 Date Created: 19th April 2025
*/

setInterval(() => {
    fetch('simulate.php')
        .then(res => res.text())
        .then(data => {
            console.log("Data:", data);
            location.reload();
        });
}, 10000); // Every 10 seconds - Can change as per need