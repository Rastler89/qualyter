import { startsWith } from "lodash";
import React from "react";
import i18n from "../helpers/i18n";

export default function Delegation(props) {

    let info = props.object;
    let clase = 'col-md-'+props.size;
    let url = info.father+'/detail/'+info.id;
    let stars = [];

    for(let i=1; i<=info.average; i++) {
        stars.push(<img key={i} src="/img/star-hover.svg" width="30" height="30" />);
    }
    if(info.average%1 > 0.5) {
        stars.push(<img key={'medians'} src="/img/star-hover-half.svg" width="30" height="30" />)
    }

    return (
        <div className={clase}>
            <div className={'card text-center'}>
                <div className={'card-header'}>
                    {info.name}
                </div>
                <div className={'card-body'}>
                    <div className={'card-title'}>
                        <h4>{info.average}</h4>
                        {stars}
                    </div>
                    <p className={'card-text'}>
                        {info.visits} {i18n.t('surveys.conducted')}
                    </p>
                </div>
                <div className={'card-footer text-muted'}>
                    <a className={'btn btn-outline-primary'} href={url}>{i18n.t('other.view_more')}</a>
                </div>
            </div>
        </div>
    )
}

