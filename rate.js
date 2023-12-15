    const stars = document.querySelectorAll('.rating input');

    stars.forEach((star) => {
        star.addEventListener('click', (e) => {
            const { target } = e;
            const rating = target.value;
            const form = target.closest('.rating-form');
            const postId = form.querySelector('input[name="post_id"]').value;

            fetch('rate.php', {
                method: 'POST',
                body: JSON.stringify({ post_id: postId, rating }),
                headers: {
                    'Content-Type': 'application/json',
                },
            }).then((response) => {
                if (response.ok) {
                    // Optionally, perform actions after successful submission
                    console.log('Rating submitted successfully.');
                }
            }).catch((error) => {
                console.error('Error:', error);
            });
        });
    });
