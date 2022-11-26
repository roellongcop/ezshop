const navbarPoll = ({totalWishlist, totalCart}) => {
	$.ajax({
		url: app.baseUrl + 'site/navbar-poll',
		data: {
			totalWishlist,
			totalCart
		},
		dataType: 'json',
		method: 'post',
		success: (s) => {

			if (s.status == 'success') {
				$('.total-wishlist').html(s.totalWishlistFormatted);
				$('.total-cart').html(s.totalCartFormatted);
				navbarPoll(s);
			}
			else {
				navbarPoll({totalWishlist, totalCart});
			}
		},
		error: (e) => {
			console.log(e)
		}

	})
}