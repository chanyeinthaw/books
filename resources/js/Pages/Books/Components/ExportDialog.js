import React, {useState} from "react";
import {Box, Button, Dialog, DialogActions, DialogContent, DialogTitle} from "@mui/material";
import FormControlSelectMenu from "./FormControlSelectMenu";

export default function ExportDialog({ open = true, onClose, onDownload}) {
    let [state, setState] = useState({
        format: 'csv',
        option: 0
    })

    let changeState = key => (event) => setState({
        ...state,
        [key]: event.target.value
    })

    let handleDownload = () => {
        onDownload(state)
        onClose()
    }

    return <Dialog open={open} onClose={onClose}>
        <DialogTitle>Export books</DialogTitle>
        <DialogContent>
            <Box display="grid" gridAutoFlow="row" gap="8px" marginTop="8px" width={"250px"}>
                <FormControlSelectMenu
                    onChange={changeState('format')}
                    items={[
                        { value: 'csv', label: 'CSV' },
                        { value: 'xml', label: 'XML' }
                    ]}
                    label={'Format'}
                    value={state.format}/>

                <FormControlSelectMenu
                    onChange={changeState('option')}
                    items={[
                        { value: 0, label: 'Full' },
                        { value: 2, label: 'Title' },
                        { value: 3, label: 'Author' },
                        { value: 1, label: 'Title and author' },
                    ]}
                    label={'Option'}
                    value={state.option}/>
            </Box>
        </DialogContent>
        <DialogActions>
            <Button onClick={onClose}>Close</Button>
            <Button onClick={handleDownload}>Download</Button>
        </DialogActions>
    </Dialog>
}