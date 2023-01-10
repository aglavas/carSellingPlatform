Nova.booting((Vue, router, store) => {
  router.addRoutes([
    {
      name: 'contact-form',
      path: '/contact-form',
      component: require('./components/Tool'),
    },
  ])
})
