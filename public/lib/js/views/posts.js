var app = app || {};


	// Our overall **AppView** is the top-level piece of UI.
	app.PostsView = Backbone.View.extend({

		el: '#upinapp',
		
/*
		initialize: function( initialPosts ) {
			this.collection = new app.Posts( initialPosts );
			this.render();
		},
*/
		
		initialize: function() {
			this.collection = new app.Posts();
			this.collection.fetch({reset: true});
			this.render();
			
			this.listenTo( this.collection, 'add', this.renderPost );
			this.listenTo( this.collection, 'reset', this.render );
		},		

		render: function () {
			this.collection.each(function( item ) {
				this.renderPost( item );
			}, this);
		},
		
		renderPost: function( item ) {
			var postView = new app.PostView({
				model: item
			});
			this.$el.append( postView.render().el );
		}
	});
