// resources/js/components/HelloReact.js

import React, { useState, useEffect} from 'react';
import { createRoot } from 'react-dom/client';
import Detail from './Detail';
import Delegation from './Delegation';
import i18n from "../helpers/i18n";

import { DateRangePicker } from 'react-date-range';
import { Dna } from  'react-loader-spinner'

const getInfo = (url,m,y) => {
    return fetch(url, {
        method: 'POST',
        headers: {
            'Accept': 'application/json',
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({init: m, final: y})
    })
    .then(res => res.json())
    .then(response => {
        const data = response;
        return data;
    });
}

export const PublicIndex= () => {
    const queryString = window.location.search;
    const urlParams = new URLSearchParams(queryString);

    if(urlParams.get('firstDay')==null) {
        var date = new Date(), y = date.getFullYear(), m = date.getMonth();
        var firstDay = new Date(y, m-1, 1);
    
        if(m===11) m=-1;
        var lastDay = new Date(y, m, 0);
    } else {
        var firstDay = new Date(urlParams.get('firstDay'));
        var lastDay = new Date(urlParams.get('lastDay'));
    }

    const [info, setInfo] = useState([]);
    const [range, setRange] = useState({
        startDate: firstDay,
        endDate: lastDay,
        key: 'selection',
      });
    const [loading, setLoading] = useState(false);
    
    let father = '';
    var URLactual = window.location.pathname;
    let array = URLactual.split('/');
    var url;
    if(array.length==3) {
        url = '/api/public/'+array[2];
    } else if(array.length==5) {
        url = '/api/public/'+array[2]+'/detail/'+array[4];
        father = <a className={'btn btn-outline-primary'} href={'/public/'+array[2]}><img width="30px" height="30px" src="/img/preview.svg" /></a>;
    }

    function change(ranges) {
        if(ranges.selection.endDate!=range.endDate && ranges.selection.startDate==range.startDate) {
            firstDay = ranges.selection.startDate;
            lastDay = ranges.selection.endDate;
            getInfo(url,ranges.selection.startDate,ranges.selection.endDate).then(data => {
                setInfo(data);
            });
        }
        setRange(ranges.selection);

    }

    var select = 
        <div className={'row mb-4'}>
            <div className={'col-md-6 mx-auto'}>
                <DateRangePicker 
                    ranges={[range]}
                    onChange={change} />
            </div>
        </div>;
    

    useEffect(() => {
        getInfo(url,null,null).then(data => {
            setInfo(data);
            setLoading(true);
        });
    }, []);

    if(!loading) {
        return (
            <div
                style={{
                    display: 'flex',
                    alignItems: 'center',
                    justifyContent: 'center',
                    height: '40vh',
                }}
                >
                    <Dna
                        visible={true}
                        height="200"
                        width="200"
                        ariaLabel="dna-loading"
                        wrapperStyle={{}}
                        wrapperClass="dna-wrapper"
                    />
            </div>)
    } else {
        if(info.type=='delegation') {
            let delegations = info.delegations;
            let size;

            switch(delegations.length) {
                case 0:
                case 1: size = 12; break;
                case 2: size = 6; break;
                case 3: size = 4; break;
                case 4:
                default: size = 3; break;
            }

            return (
                <section>
                    {select}
                    <div className={'row'}>
                        {delegations.map((delegation) => 
                            <Delegation object={delegation} size={size} firstDay={range.startDate} lastDay={range.endDate} />
                        )}
                    </div>
                </section>
            )
        } else {
            return (
                <section>
                    {father}
                    {select}
                    <Detail object={info}/>
                </section>
            )
        }
    }
}

const container = document.getElementById('public-index');
const root = createRoot(container);
root.render(<PublicIndex />)