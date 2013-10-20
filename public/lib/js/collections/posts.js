var app = app || {};

// Post List Collection
// ---------------

app.Posts = Backbone.Collection.extend({
	/* model: app.Post */
	model: app.Post,
	url: '/api/posts',
	parse: function ( response ) {
		return response.posts
	}
});