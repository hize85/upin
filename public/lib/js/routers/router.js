/*global Backbone */
var app = app || {};

(function () {
	'use strict';

	// Post Router
	// ----------
	var Workspace = Backbone.Router.extend({
		routes: {
			'*filter': 'setFilter'
		},

		setFilter: function (param) {
			// Set the current filter to be used
			app.PostFilter = param || '';

			// Trigger a collection filter event, causing hiding/unhiding
			// of Todo view items
			app.posts.trigger('filter');
		}
	});

	app.PostRouter = new Workspace();
	Backbone.history.start();
})();