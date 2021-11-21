import React, {useRef, useState} from "react";
import {Box, Paper, Typography} from "@mui/material";
import {UploadFileOutlined} from "@mui/icons-material";
import {BookImage} from "./Book";

export default function ImageChooser({ image, name, onChange, disabled, error }) {
    let fileRef = useRef()
    let [imageObject, setImageObject] = useState(image)

    let openImageChooser = () => {
        if (disabled) return
        fileRef.current?.click()
    }

    let setImageFile = event => {
        setImageObject(URL.createObjectURL(event.target.files[0]))
        onChange(event.target.files[0])
    }

    return (
        <Paper elevation={1} onClick={openImageChooser} sx={{
            width: 150,
            height: 250,
            overflow: 'hidden',
            gridArea: 'book',
            cursor: 'pointer',
            border: error ? '1px solid red': undefined
        }}>
            <input onChange={setImageFile} accept={"image/png,image/jpg,image/jpeg"} style={{ display: 'none' }} type={"file"} name={name} ref={fileRef}/>
            {!imageObject ?
                <Box display={'grid'} gap="4px"
                     sx={{placeItems: 'center', placeContent: 'center', height: '100%'}}>
                    <UploadFileOutlined color={"primary"} fontSize={"large"}/>
                    <Typography variant={"caption"} color={"primary"}>Upload image</Typography>
                </Box> :
                <BookImage src={imageObject} width={150} height={250}/>
            }
        </Paper>
    )
}