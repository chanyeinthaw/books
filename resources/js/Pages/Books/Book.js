import React, {useEffect} from 'react'
import {usePage} from "@inertiajs/inertia-react";

function Book() {
    let { error, book } = usePage().props

    useEffect(() => {
        console.log(error, book)
    }, [])

    return (
        <ul>
            { book?.title }
        </ul>
    )
}

export default Book