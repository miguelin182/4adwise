// package metadata file for Meteor.js

Package.describe({
  name: 'twbs:bootstrap v4.3.1', // https://atmospherejs.com/twbs/bootstrap
  summary: 'The most popular front-end framework for developing responsive, mobile first projects on the web.',
  version: '4.3.1',
  git: 'https://github.com/twbs/bootstrap v4.3.1.git'
});

Package.onUse(function (api) {
  api.versionsFrom('METEOR@1.0');
  api.use('jquery', 'client');
  api.addFiles([
    'dist/css/bootstrap v4.3.1.css',
    'dist/js/bootstrap v4.3.1.js'
  ], 'client');
});
