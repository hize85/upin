var app = app || {};

	// Post Item View
	// --------------

	app.PostView = Backbone.View.extend({
		tagName:  'div',
		className: 'post',
		template: _.template($('#postTemplate').html()),

		render: function () {
			this.$el.html(this.template(this.model.toJSON()));
			
			return this;
		}
	});