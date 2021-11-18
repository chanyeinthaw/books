import {Box, Popover, styled, Typography} from "@mui/material";
import {KeyboardArrowDownOutlined} from "@mui/icons-material";
import React, {useState} from "react";

export default function SortingMenu({ onItemClick, text, items, queryKey, defaultValue }) {
    let [anchorEl, setAnchorEl] = useState(null)
    let sortBy = new URLSearchParams(window.location.search).get(queryKey) ?? defaultValue

    let itemClicked = key => e => {
        e.stopPropagation()
        setAnchorEl(null)
        onItemClick(key)
    }

    let capitalizeFirstLetter = (str) => str.replace(/^\w/, c => c.toUpperCase())

    return <Box sx={{
        cursor: "pointer",
        position: "relative"
    }}
        onClick={e => setAnchorEl(e.currentTarget)}
        justifySelf={"start"}
        gridTemplateColumns={"max-content auto"} alignItems={"center"} display={"grid"} gap={'4px'} gridAutoFlow={"column"}>
        <Typography variant={"caption"} color={"primary"}>
            {text}: {capitalizeFirstLetter(sortBy)}
        </Typography>
        <KeyboardArrowDownOutlined color={"primary"} />
        <Popover
            anchorOrigin={{
                vertical: "bottom",
                horizontal: "right"
            }}
            transformOrigin={{
                vertical: "top",
                horizontal: "right"
            }}
            onClose={e => {
                e.stopPropagation()
                setAnchorEl(null)
            }}
            anchorEl={anchorEl}
            open={!!anchorEl}>
            <Box display={"flex"} flexDirection={"column"}>
                { items.map(item => (
                    <StyledTypography key={item} onClick={itemClicked(item)} variant={"caption"} color={"primary"}>{capitalizeFirstLetter(item)}</StyledTypography>
                )) }
            </Box>
        </Popover>
    </Box>
}

let StyledTypography = styled(Typography)(({theme}) => ({
    cursor: 'pointer',
    padding: '8px 16px',
    '&:hover': {
        backgroundColor: theme.palette.primary.light,
        color: theme.palette.background.paper
    }
}))