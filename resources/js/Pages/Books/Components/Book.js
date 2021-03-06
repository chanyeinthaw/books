import React from 'react'
import {Link} from "@inertiajs/inertia-react";
import {Paper} from "@mui/material";
import styled from "@emotion/styled";
import {PriorityHighOutlined} from "@mui/icons-material";

export default function Book({ book, width = 150, height = 250, invalid = false, sx = {} }) {
    let invalidStyles = {
        display: 'grid',
        placeContent: 'center'
    }

    return <Paper elevation={1} sx={{
        width,
        height,
        overflow: "hidden",
        ...sx,
        ...(invalid ? invalidStyles : {})
    }} >
        { invalid ? <PriorityHighOutlined color="primary" sx={{ fontSize: 84 }}/> :
        <Link href={`/${book.id}`}>
            <BookImage src={book.image} alt={book.title} width={width} height={height}/>
        </Link> }
    </Paper>
}

export const BookImage = styled.img`
    object-fit: cover;
    width: ${props => props.width}px;
    height: ${props => props.height}px;
`