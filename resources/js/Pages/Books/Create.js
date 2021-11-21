import React, {useRef, useState} from 'react'
import {useForm, usePage} from "@inertiajs/inertia-react";
import BookDetailLayout from "./Layouts/BookDetailLayout";
import {TextField} from "@mui/material";
import {SaveOutlined} from "@mui/icons-material";
import styled from "@emotion/styled";
import {Inertia} from "@inertiajs/inertia";
import {LoadingButton} from '@mui/lab';
import ImageChooser from "./Components/ImageChooser";

function Create() {
    let bookFormRef = useRef()
    let { book } = usePage().props
    let [updating, setUpdating] = useState(false)

    let { data, setData, post, processing , errors, clearErrors } = useForm({
        title: book?.title ?? '',
        author: book?.author ?? '',
        image: undefined,
        description: book?.description ?? ''
    })

    let inputChangeHandler = key => event => {
        setData(key, event.target.value)
        clearErrors(key)
    }

    let processingOrUpdating = processing || updating

    let onSubmit = () => {
        if (book) {
            setUpdating(true)
            Inertia.post(route('books.update', [book.id]), {
                _method: 'PATCH',
                ...data
            })
        } else return post(route('books.create'))
    }

    return (
        <BookDetailLayout navigateBack={!!book} sx={{gridColumnGap: 32}} buttons={[
            <div>&nbsp;</div>,
            <LoadingButton loading={processingOrUpdating} loadingPosition={"start"} onClick={onSubmit} variant={"text"} color={"primary"} startIcon={<SaveOutlined />}>Save</LoadingButton>
        ]}>
            <ImageChooser image={book?.image} error={errors.image} onChange={image => {
                setData('image', image)
                clearErrors('image')
            }} disabled={processingOrUpdating}/>
            <StyledForm method={'POST'} ref={bookFormRef} >
                <TextField
                    disabled={processingOrUpdating}
                    error={errors.title}
                    helperText={errors.title}
                    value={data.title}
                    onChange={inputChangeHandler('title')}
                    name={'title'}
                    size={"small"}
                    placeholder={'Book title'}
                    label={'Title'}
                    variant={"outlined"} />
                <TextField
                    error={errors.author}
                    helperText={errors.author}
                    disabled={processingOrUpdating}
                    value={data.author}
                    onChange={inputChangeHandler('author')}
                    name={'author'}
                    size={"small"}
                    placeholder={'Author'}
                    label={'Author'}
                    variant={"outlined"} />
                <TextField
                    minRows={5}
                    error={errors.description}
                    helperText={errors.description}
                    disabled={processing}
                    value={data.description}
                    onChange={inputChangeHandler('description')}
                    multiline={true}
                    name={'description'}
                    size={"small"}
                    placeholder={'Description'}
                    label={'Description'}
                    variant={"outlined"} />
            </StyledForm>
        </BookDetailLayout>
    )
}

let StyledForm = styled.form`
   display: flex;
   flex-direction: column;
   width: 400px;
   &>div {
      margin-bottom: 16px;
   }
`

export default Create