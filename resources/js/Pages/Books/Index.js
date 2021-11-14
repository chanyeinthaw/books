import React, {useEffect} from 'react'
import {usePage} from "@inertiajs/inertia-react";
import {Inertia} from "@inertiajs/inertia";

function Index() {
    let { error, flash, books } = usePage().props

    useEffect(() => {
        console.log(error, flash)
    }, [])

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