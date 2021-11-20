import React, {useEffect, useState} from "react";
import {
    Box,
    Button,
    InputAdornment,
    TextField
} from "@mui/material";
import {AddCircleOutline, Close, ImportExport, SearchOutlined} from "@mui/icons-material";
import ExportDialog from "./ExportDialog";

export default function Actions({ onQuery, onClear }) {
    let [query, setQuery] = useState('')
    let [openExportDialog, setOpenExportDialog] = useState(false)

    useEffect(() => {
        setQuery(new URLSearchParams(window.location.search).get('query') ?? '')
    }, [])

    let clearQuery = () => {
        setQuery('')
        onClear()
    }

    let handleDownload = ({ option, format }) => {
        let url = `${route('books.export')}?format=${format}&option=${option}`

        window.open(url, '_blank').focus()
    }

    return (
        <Box gridArea={'action'} display={'grid'} gridTemplateColumns={'1fr auto'} columnGap={'102px'}>
            <ExportDialog open={openExportDialog} onClose={() => setOpenExportDialog(false)} onDownload={handleDownload}/>
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
                <Button variant={'outlined'} size={"small"} startIcon={<ImportExport />} onClick={() => setOpenExportDialog(true)}>
                    Export
                </Button>
                <Button href={route('books.create.render')} variant={"contained"} size={"small"} startIcon={<AddCircleOutline />}>
                    New book
                </Button>
            </Box>
        </Box>
    )
}