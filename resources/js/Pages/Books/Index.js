import React, {useState} from 'react'
import {usePage} from "@inertiajs/inertia-react";
import {Inertia} from "@inertiajs/inertia";
import {Box, Pagination } from "@mui/material";
import Book from "./Components/Book";
import Actions from "./Components/Actions";
import SortingMenu from "./Components/SortingMenu";
import useNotificationStack from "./Hooks/useNotificationStack";

function Index() {
    let { books, meta } = usePage().props
    let [direction, setDirection] = useState('asc')
    useNotificationStack()

    let refresh = ({ query, page , sortBy, direction }) => {
        let params = new URLSearchParams(window.location.search)

        query = query === '' ? undefined : query ?? params.get('query') ?? undefined

        Inertia.get(route('books.index'), {
            page: page ?? params.get('page') ?? undefined,
            sortBy: sortBy ?? params.get('sortBy') ?? undefined,
            query,
            direction: direction ?? params.get('direction') ?? undefined
        }, {
            replace: true,
            preserveState: true
        })
    }

    let paginate = (event, page) => {
        refresh({ page })
    }

    let query = (event) => {
        refresh({
            query: event.target.value
        })
    }

    let clear = () => {
        refresh({ query: '' })
    }

    let changeDirection = direction => {
        setDirection(direction)

        refresh({ direction })
    }

    let sort = (sortBy) => {
        refresh({ sortBy })
    }

    return (
        <Box width={'886px'} display={"grid"} gridTemplateAreas={"'action''books'"} gap={'48px'}>
            <Actions onQuery={query} onClear={clear}/>

            <Box display={"grid"} gridArea={'books'} gridAutoFlow={"row"} rowGap={'16px'}>
                <Box display={'grid'} gridTemplateColumns={'max-content max-content'} columnGap={'16px'}>
                    <SortingMenu onItemClick={sort} text={'Sort by'} queryKey={'sortBy'} defaultValue='default' items={['default', 'title', 'author']}/>
                    <SortingMenu onItemClick={changeDirection} text={'Direction'} queryKey={'direction'} defaultValue={direction} items={['asc', 'desc']}/>
                </Box>
                <Box display={"grid"} gridTemplateColumns={"repeat(auto-fill, 150px)"} rowGap={'32px'} justifyContent={"space-between"}>
                    { books.map((book) => <Book key={book.id} book={book} />) }
                    { books.length <= 5 &&
                    Array.from({ length: 6 - books.length })
                        .map((_, i) => <div style={{height: 250}} key={i} />)
                    }
                </Box>
            </Box>

            <Pagination sx={{ justifySelf: 'center' }}
                        onChange={paginate}
                        hidePrevButton={meta.current_page === 1}
                        hideNextButton={meta.current_page === meta.last_page}
                        count={meta.last_page}
                        color={"primary"}
                        page={meta.current_page} />
        </Box>
    )
}

export default Index