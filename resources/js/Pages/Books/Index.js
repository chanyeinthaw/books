import React from 'react'
import {usePage} from "@inertiajs/inertia-react";
import {Inertia} from "@inertiajs/inertia";

function Index() {
    let { books } = usePage().props

    let requestMore = () => {
        Inertia.get(route('books.index'), {
            skip: 1,
            limit: 16
        }, {
            replace: true,
            preserveState: true
        })
    }
    return (
        <ul>
            { books.map(book => (
                <li key={book.id} onClick={requestMore}>{book.title}</li>
            ))}
        </ul>
    )
}

export default Index