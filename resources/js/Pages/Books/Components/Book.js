import React from 'react'
import {Link} from "@inertiajs/inertia-react";
import {Paper} from "@mui/material";
import styled from "@emotion/styled";

export default function Book({ book, width = 150, height = 250 }) {
    return <Paper key={book.id} elevation={1} sx={{
        width,
        height,
        overflow: "hidden"
    }} >
        <Link href={`/${book.id}`}>
            <BookImage src={book.image} alt={book.title} width={width} height={height}/>
        </Link>
    </Paper>
}

let BookImage = styled.img`
    width: ${props => props.width}px;
    height: ${props => props.height}px;
`