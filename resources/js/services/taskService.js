import { sha256 } from "js-sha256";

const createTask = (data) => axios.post('/api/tasks', data)

const updateTask = (id, data) => axios.put(`/api/tasks/${id}`, data)

const getAvatarByUser = (user)  => {
    if (user.profile_picture_url !== null) {
        return user.profile_picture_url;
    } else {
        return ("https://www.gravatar.com/avatar/" + sha256(String(user.email).trim().toLowerCase()) + "?size=400");
    }
}

export { createTask, updateTask, getAvatarByUser }
