import React from 'react'
import {usePage} from "@inertiajs/inertia-react";
import Book from "./Components/Book";
import {Box, Button, Typography} from "@mui/material";
import {DeleteOutlined, EditOutlined} from "@mui/icons-material";
import BookDetailLayout from "./Layouts/BookDetailLayout";
import useHandleBookDelete from "./Hooks/useHandleBookDelete";
import useNotificationStack from "./Hooks/useNotificationStack";

function BookPage() {
    useNotificationStack()
    let { error, book } = usePage().props

    let handleDelete = useHandleBookDelete();

    return (
        <BookDetailLayout error={error} buttons={[
            <Button onClick={_ => handleDelete(book.id)} variant={'text'} startIcon={<DeleteOutlined />} color={"error"} size={"small"}>Delete</Button>,
            <Button href={route('books.update.render', [book?.id ?? 0])} variant={'text'} startIcon={<EditOutlined />} color={"primary"} size={"small"}>Edit</Button>
        ]}>
            <Book sx={{ gridArea: 'book' }} book={book} invalid={!!error} />
            <Box display={"flex"} flexDirection={"column"} sx={{
                width: '400px',
                overflow: 'hidden'
            }}>
                <Typography variant={'h3'} color={"primary"} sx={{
                    textTransform: "uppercase"
                }} >{book?.title ?? 'NO SUCH BOOK'}</Typography>
                <Typography variant={'button'} color={"primary"} >{book?.author ?? 'Unknown'}</Typography>
                <Typography variant={'caption'} color={"primary"} marginTop={"24px"} >{book?.description ?? 'This book does not exist!'}</Typography>
            </Box>
        </BookDetailLayout>
    )
}

export default BookPage