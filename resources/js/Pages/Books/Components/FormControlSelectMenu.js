import {FormControl, InputLabel, MenuItem, Select} from "@mui/material";

export default function FormControlSelectMenu({ value, label, items, onChange}) {
    return <FormControl>
        <InputLabel>{label}</InputLabel>
        <Select value={value} label={label} onChange={onChange}>
            { items.map(item => (
                <MenuItem value={item.value} key={item.value}>{item.label}</MenuItem>
            )) }
        </Select>
    </FormControl>
}