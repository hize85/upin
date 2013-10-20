var app = app || {};

	// Post Model
	// ----------s

	app.Post = Backbone.Model.extend({
		defaults: {
			id: '',
			user_id: '',
			created: '',
			title: '',
			description: '',
			image: ''
		}
	});