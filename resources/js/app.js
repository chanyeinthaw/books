import React from 'react'
import { render } from 'react-dom'
import { createInertiaApp } from '@inertiajs/inertia-react'

createInertiaApp({
    resolve: name => import(`./Pages/${name}`).then(module => module.default),
    setup({el, App, props}) {
        render(<App {...props} />, el)
    },
}).then()