import React, {useEffect, useState} from "react";
import {Box, Button, InputAdornment, TextField} from "@mui/material";
import {AddCircleOutline, Close, ImportExport, SearchOutlined} from "@mui/icons-material";

export default function Actions({ onQuery, onClear }) {
    let [query, setQuery] = useState('')

    useEffect(() => {
        setQuery(new URLSearchParams(window.location.search).get('query') ?? '')
    }, [])

    let clearQuery = () => {
        setQuery('')
        onClear()
    }

    return (
        <Box gridArea={'action'} display={'grid'} gridTemplateColumns={'1fr auto'} columnGap={'102px'}>
            <TextField
                value={query}
                onKeyDown={(event) => {
                    if (event.key === "Escape") clearQuery()
                }}
                onChange={(event) => {
                    setQuery(event.target.value)
                    onQuery(event)
                }}
                InputProps={{
                    startAdornment: (
                        <InputAdornment position={"start"}>
                            <SearchOutlined />
                        </InputAdornment>
                    ),
                    endAdornment: query.length > 0 && (
                        <InputAdornment sx={{ cursor: "pointer" }} position={"end"} onClick={clearQuery}>
                            <Close />
                        </InputAdornment>
                    )
                }}
                hiddenLabel
                size={'small'}
                placeholder={'Search'}
                variant={'outlined'}
            />
            <Box gridTemplateColumns={'1fr 1fr'} display={'grid'} columnGap={'8px'}>
                <Button variant={'outlined'} size={"small"} startIcon={<ImportExport />}>
                    Export
                </Button>
                <Button variant={"contained"} size={"small"} startIcon={<AddCircleOutline />}>
                    New book
                </Button>
            </Box>
        </Box>
    )
}
